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
<div class="container" style="width:90%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<h4 class="card-title text-center"><?php echo $title ?></h4>
			<div class="content-area">

				<!-- years -->
				<div class="row justify-content-center">
					<div class="col-sm-10 col-md-8 mb-3">
						<label>年度</label>
						<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

							<?php foreach ($years as $i) { ?>

								<option <?php echo ($yearType == $i['year']) ? 'selected' : '' ?> value="<?php echo site_url($url . $reportType . '/' . $countyType . '/' . $i['year']); ?>"><?php echo $i['year'] ?></option>
							<?php } ?>

						</select>
					</div>
				</div>

				<!-- counties -->
				<div class="row justify-content-center">
					<div class="col-sm-10 col-md-8 mb-3">
						<label>縣市</label>
						<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
							<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url($url . $reportType . '/all/' . $yearType); ?>">全部</option>
							<?php foreach ($counties as $i) { ?>
								<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url($url . $reportType . '/' . $i['no'] . '/' . $yearType); ?>"><?php echo $i['name'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<!-- reportType -->
				<div class="row justify-content-center">
					<div class="col-sm-10 col-md-8 mb-3">
						<label>報表類型</label>
						<select class="form-select form-select-lg" name="reportType" id="reportType" onchange="location = this.value;">
							<option <?php echo ($reportType == 'all') ? 'selected' : '' ?> value="<?php echo site_url($url . 'all/' . $countyType . '/' . $yearType); ?>">全部</option>
							<option <?php echo ($reportType == 'countyDelegateOrganization') ? 'selected' : '' ?> value="<?php echo site_url($url . 'countyDelegateOrganization/' . $countyType . '/' . $yearType); ?>">各縣市各年度計畫清單</option>
							<option <?php echo ($reportType == 'counselEffection') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffection/' . $countyType . '/' . $yearType); ?>">輔導成效統計表</option>
							<option <?php echo ($reportType == 'counselEffectionIndividual') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffectionIndividual/' . $countyType . '/' . $yearType); ?>">個別輔導時數統計表</option>
							<option <?php echo ($reportType == 'counselEffectionGroup') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffectionGroup/' . $countyType . '/' . $yearType); ?>">團體輔導時數統計表</option>
							<option <?php echo ($reportType == 'counselEffectionCourse') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffectionCourse/' . $countyType . '/' . $yearType); ?>">生涯探索課程或活動時數統計表</option>
							<option <?php echo ($reportType == 'counselEffectionWork') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffectionWork/' . $countyType . '/' . $yearType); ?>">工作體驗時數統計表</option>
							<option <?php echo ($reportType == 'counselEffectionMeeting') ? 'selected' : '' ?> value="<?php echo site_url($url . 'counselEffectionMeeting/' . $countyType . '/' . $yearType); ?>">跨局處會議及預防性講座統計表</option>
							<option <?php echo ($reportType == 'surveyTypeOldCaseTrack') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeOldCaseTrack/' . $countyType . '/' . $yearType); ?>">去年度開案學員動向調查追蹤表</option>
							<option <?php echo ($reportType == 'surveyTypeTwoYears') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeTwoYears/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查表</option>
							<option <?php echo ($reportType == 'surveyTypeOneYears') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeOneYears/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查表</option>
							<option <?php echo ($reportType == 'surveyTypeNowYears') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeNowYears/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查表</option>
							<option <?php echo ($reportType == 'surveyTypeHighSchoolTrack') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeHighSchoolTrack/' . $countyType . '/' . $yearType); ?>">109學年度高中已錄取未註冊青少年動向調查追蹤表</option>
							<option <?php echo ($reportType == 'surveyTypeTwoYearsTrack') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeTwoYearsTrack/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</option>
							<option <?php echo ($reportType == 'surveyTypeOneYearsTrack') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeOneYearsTrack/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</option>
							<option <?php echo ($reportType == 'surveyTypeNowYearsTrack') ? 'selected' : '' ?> value="<?php echo site_url($url . 'surveyTypeNowYearsTrack/' . $countyType . '/' . $yearType); ?>"><?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</option>
						</select>
					</div>
				</div>

				<?php if ($reportType == 'all') { ?>
					<div class="row justify-content-center">
						<div class="col-sm-3">
							<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'all' . '/' . $yearType); ?>">列印全部(下載CSV檔)</a><br /><br />
						</div>
					</div>
				<?php } ?>

				<?php if ($reportType == 'countyDelegateOrganization' || $reportType == 'all') { ?>
					<h4>各縣市各年度計畫清單</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.countyDelegateOrganization', '各縣市各年度計畫清單.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'countyDelegateOrganization' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="countyDelegateOrganization table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">計<br />畫<br />名<br />稱</th>
									<th scope="col">機<br />構<br />名<br />稱</th>
									<th scope="col">機<br />構<br />電<br />話</th>
									<th scope="col">機<br />構<br />地<br />址</th>
									<th scope="col">辦<br />理<br />模<br />式</th>
									<th scope="col">辦<br />理<br />方<br />式</th>
									<th scope="col">輔<br />導<br />員<br />數<br />量</th>
									<th scope="col">跨<br />局<br />處<br />會<br />議<br />次<br />數</th>
									<th scope="col">輔<br />導<br />會<br />談<br />-<br />人<br />數</th>
									<th scope="col">輔<br />導<br />會<br />談<br />-<br />小<br />時<br />/<br />人</th>
									<th scope="col">生<br />涯<br />探<br />索<br />課<br />程<br />-<br />小<br />時</th>
									<th scope="col">工<br />作<br />體<br />驗<br />-<br />人<br />數</th>
									<th scope="col">工<br />作<br />體<br />驗<br />-<br />小<br />時</th>
									<th scope="col">計<br />畫<br />經<br />費</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($countyDelegateOrganizations as $i) { ?>
									<tr>
										<td><?php echo $i['countyName']; ?></td>
										<td><?php echo $i['projectName']; ?></td>
										<td><?php echo $i['organizationName']; ?></td>
										<td><?php echo $i['organizationPhone']; ?></td>
										<td><?php echo $i['organizationAddress']; ?></td>
										<td><?php foreach ($executeModes as $value) {
												if ($value['no'] == $i['executeMode']) {
													echo $value['content'];
												}
											} ?></td>
										<td><?php foreach ($executeWays as $value) {
												if ($value['no'] == $i['executeWay']) {
													echo $value['content'];
												}
											} ?></td>
										<td><?php echo $i['counselorCount']; ?></td>
										<td><?php echo $i['meetingCount']; ?></td>
										<td><?php echo $i['counselingMember']; ?></td>
										<td><?php echo $i['counselingHour']; ?></td>
										<td><?php echo $i['courseHour']; ?></td>
										<td><?php echo $i['workingMember']; ?></td>
										<td><?php echo $i['workingHour']; ?></td>
										<td><?php echo number_format($i['funding']); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffection' || $reportType == 'all') { ?>
					<h4>輔導成效統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffection', '輔導成效統計表.csv')">列印(下載CSV檔)</a> <br/><br/> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffection' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="counselEffection table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col" rowspan="2">縣市 / 類別</th>
									<th scope="col" rowspan="2">青少年總人數</th>
									<th scope="col" rowspan="2">學員總人數</th>
									<th scope="col" colspan="2">關懷追蹤</th>
									<th scope="col" colspan="2">措施A總計時數</th>
									<th scope="col" rowspan="2">措施B-課程總計時數</th>
									<th scope="col" rowspan="2">措施C-工作總計時數</th>
									<th scope="col" rowspan="2">結案總人數</th>
								</tr>
								<tr>
									<th scope="col">季追蹤</th>
									<th scope="col">月追蹤</th>
									<th scope="col">個別輔導</th>
									<th scope="col">團體輔導</th>
								</tr>
							</thead>

							<tbody>

								<?php foreach ($counselEffectionCounts as $i) { ?>
									<tr>
										<td rowspan="2"><?php echo $i['name']; ?></td>
										<td rowspan="2"><?php echo $i['schoolSourceCount'] + $i['highSourceCount']; ?></td>
										<td rowspan="2"><?php echo $i['memberCount']; ?></td>
										<td colspan="2"><?php echo $i['seasonalReviewCount'] + $i['monthReviewCount']; ?></td>
										<td colspan="2"><?php echo $i['individualCounselingCount'] + $i['groupCounselingCount']; ?></td>
										<td rowspan="2"><?php echo $i['courseAttendanceCount']; ?></td>
										<td rowspan="2"><?php echo $i['workAttendanceCount']; ?></td>
										<td rowspan="2"><?php echo $i['endCaseCount']; ?></td>
									</tr>
									<tr>
										<td><?php echo $i['seasonalReviewCount']; ?></td>
										<td><?php echo $i['monthReviewCount']; ?></td>
										<td><?php echo $i['individualCounselingCount']; ?></td>
										<td><?php echo $i['groupCounselingCount']; ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td rowspan="2">總計</td>
									<td rowspan="2"><?php echo $counselEffectionCountsSumDetail['schoolSourceCount'] + $counselEffectionCountsSumDetail['highSourceCount']; ?></td>
									<td rowspan="2"><?php echo $counselEffectionCountsSumDetail['memberCount']; ?></td>
									<td colspan="2"><?php echo $counselEffectionCountsSumDetail['seasonalReviewCount'] + $counselEffectionCountsSumDetail['monthReviewCount']; ?></td>
									<td colspan="2"><?php echo $counselEffectionCountsSumDetail['individualCounselingCount'] + $counselEffectionCountsSumDetail['groupCounselingCount']; ?></td>
									<td rowspan="2"><?php echo $counselEffectionCountsSumDetail['courseAttendanceCount']; ?></td>
									<td rowspan="2"><?php echo $counselEffectionCountsSumDetail['workAttendanceCount']; ?></td>
									<td rowspan="2"><?php echo $counselEffectionCountsSumDetail['endCaseCount']; ?></td>
								</tr>
								<tr>
									<td><?php echo $counselEffectionCountsSumDetail['seasonalReviewCount']; ?></td>
									<td><?php echo $counselEffectionCountsSumDetail['monthReviewCount']; ?></td>
									<td><?php echo $counselEffectionCountsSumDetail['individualCounselingCount']; ?></td>
									<td><?php echo $counselEffectionCountsSumDetail['groupCounselingCount']; ?></td>
								</tr>

							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffectionIndividual' || $reportType == 'all') { ?>
					<h4>個別輔導時數統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffectionIndividual', '個別輔導時數統計表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffectionIndividual' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="counselEffectionIndividual table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col" rowspan="2">縣市</th>
									<th scope="col" colspan="3">個案服務時數</th>
									<th scope="col" colspan="7">系統服務時數</th>
									<th scope="col" rowspan="2">個別輔導總時數</th>
								</tr>
								<tr>
									<th scope="col">電訪</th>
									<th scope="col">親訪</th>
									<th scope="col">網路</th>
									<th scope="col">教育資源</th>
									<th scope="col">勞政資源</th>
									<th scope="col">社政資源</th>
									<th scope="col">警政資源</th>
									<th scope="col">司法資源</th>
									<th scope="col">衛政資源</th>
									<th scope="col">其他資源</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($counselEffectionIndividual as $i) { ?>
									<tr>
										<td rowspan="2"><?php echo $i ? $i['name'] : null ?></td>
										<td colspan="3"><?php echo $i ? $i['phoneServiceCount'] + $i['personallyServiceCount'] + $i['internetServiceCount'] : null ?></td>
										<td colspan="7"><?php echo $i ? $i['educationServiceCount'] + $i['laborServiceCount'] + $i['socialServiceCount'] + $i['officeServiceCount']
															+ $i['judicialServiceCount'] + $i['healthServiceCount'] + $i['otherServiceCount'] : null ?></td>

										<td rowspan="2"><?php echo $i ? $i['phoneServiceCount'] + $i['personallyServiceCount'] + $i['internetServiceCount']
															+ $i['educationServiceCount'] + $i['laborServiceCount'] + $i['socialServiceCount'] + $i['officeServiceCount']
															+ $i['judicialServiceCount'] + $i['healthServiceCount'] + $i['otherServiceCount'] : null ?></td>
									</tr>

									<tr>
										<td><?php echo $i ? $i['phoneServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['personallyServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['internetServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['educationServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['laborServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['socialServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['officeServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['judicialServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['healthServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['otherServiceCount'] : null ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td rowspan="2">總計</td>
									<td colspan="3"><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['phoneServiceCount'] + $counselEffectionIndividualSumDetail['personallyServiceCount'] + $counselEffectionIndividualSumDetail['internetServiceCount'] : null ?></td>
									<td colspan="7"><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['educationServiceCount'] + $counselEffectionIndividualSumDetail['laborServiceCount'] + $counselEffectionIndividualSumDetail['socialServiceCount'] + $counselEffectionIndividualSumDetail['officeServiceCount']
														+ $counselEffectionIndividualSumDetail['judicialServiceCount'] + $counselEffectionIndividualSumDetail['healthServiceCount'] + $counselEffectionIndividualSumDetail['otherServiceCount'] : null ?></td>

									<td rowspan="2"><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['phoneServiceCount'] + $counselEffectionIndividualSumDetail['personallyServiceCount'] + $counselEffectionIndividualSumDetail['internetServiceCount']
														+ $counselEffectionIndividualSumDetail['educationServiceCount'] + $counselEffectionIndividualSumDetail['laborServiceCount'] + $counselEffectionIndividualSumDetail['socialServiceCount'] + $counselEffectionIndividualSumDetail['officeServiceCount']
														+ $counselEffectionIndividualSumDetail['judicialServiceCount'] + $counselEffectionIndividualSumDetail['healthServiceCount'] + $counselEffectionIndividualSumDetail['otherServiceCount'] : null ?></td>
								</tr>

								<tr>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['phoneServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['personallyServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['internetServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['educationServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['laborServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['socialServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['officeServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['judicialServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['healthServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionIndividualSumDetail ? $counselEffectionIndividualSumDetail['otherServiceCount'] : null ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffectionGroup' || $reportType == 'all') { ?>
					<h4>團體輔導時數統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffectionGroup', '團體輔導時數統計表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffectionGroup' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="counselEffectionGroup table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">生涯探索</th>
									<th scope="col">人際溝通與互動</th>
									<th scope="col">體驗教育</th>
									<th scope="col">環境教育</th>
									<th scope="col">法治教育</th>
									<th scope="col">性別平等教育</th>
									<th scope="col">職業訓練</th>
									<th scope="col">志願服務</th>
									<th scope="col">其他</th>
									<th scope="col">團體輔導總時數</th>
							</thead>
							<tbody>
								<?php foreach ($counselEffectionGroup as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['exploreServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['interactiveServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['experienceServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['environmentServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['judicialServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['genderServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['professionServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['volunteerServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['otherServiceCount'] : null ?></td>
										<td><?php echo $i ? $i['exploreServiceCount'] + $i['interactiveServiceCount'] + $i['experienceServiceCount'] + $i['environmentServiceCount']
												+ $i['judicialServiceCount'] + $i['genderServiceCount'] + $i['professionServiceCount'] + $i['volunteerServiceCount'] + $i['otherServiceCount'] : null ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['exploreServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['interactiveServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['experienceServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['environmentServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['judicialServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['genderServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['professionServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['volunteerServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['otherServiceCount'] : null ?></td>
									<td><?php echo $counselEffectionGroupSumDetail ? $counselEffectionGroupSumDetail['exploreServiceCount'] + $counselEffectionGroupSumDetail['interactiveServiceCount'] + $counselEffectionGroupSumDetail['experienceServiceCount'] + $counselEffectionGroupSumDetail['environmentServiceCount']
											+ $counselEffectionGroupSumDetail['judicialServiceCount'] + $counselEffectionGroupSumDetail['genderServiceCount'] + $counselEffectionGroupSumDetail['professionServiceCount'] + $counselEffectionGroupSumDetail['volunteerServiceCount'] + $counselEffectionGroupSumDetail['otherServiceCount'] : null ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffectionCourse' || $reportType == 'all') { ?>
					<h4>生涯探索課程或活動時數統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffectionCourse', '生涯探索課程或活動時數統計表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffectionCourse' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="counselEffectionCourse table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">生涯探索與就業力培訓</th>
									<th scope="col">體驗教育及志願服務</th>
									<th scope="col">法治(含反毒)及性別平等教育</th>
									<th scope="col">其他及彈性運用</th>
									<th scope="col">生涯探索課程或活動總時數</th>
							</thead>
							<tbody>
								<?php foreach ($counselEffectionCourse as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['exploreCourseCount'] : null ?></td>
										<td><?php echo $i ? $i['experienceCourseCount'] : null ?></td>
										<td><?php echo $i ? $i['officeCourseCount'] : null ?></td>
										<td><?php echo $i ? $i['otherCourseCount'] : null ?></td>

										<td><?php echo $i ? $i['exploreCourseCount'] + $i['experienceCourseCount'] + $i['officeCourseCount'] + $i['otherCourseCount'] : null ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $counselEffectionCourseSumDetail ? $counselEffectionCourseSumDetail['exploreCourseCount'] : null ?></td>
									<td><?php echo $counselEffectionCourseSumDetail ? $counselEffectionCourseSumDetail['experienceCourseCount'] : null ?></td>
									<td><?php echo $counselEffectionCourseSumDetail ? $counselEffectionCourseSumDetail['officeCourseCount'] : null ?></td>
									<td><?php echo $counselEffectionCourseSumDetail ? $counselEffectionCourseSumDetail['otherCourseCount'] : null ?></td>

									<td><?php echo $counselEffectionCourseSumDetail ? $counselEffectionCourseSumDetail['exploreCourseCount'] + $counselEffectionCourseSumDetail['experienceCourseCount'] + $counselEffectionCourseSumDetail['officeCourseCount'] + $counselEffectionCourseSumDetail['otherCourseCount'] : null ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffectionWork' || $reportType == 'all') { ?>
					<h4>工作體驗時數統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffectionWork', '工作體驗時數統計表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffectionWork' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px; width:850px;">
						<table class="counselEffectionWork table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">農、林、漁、牧業</th>
									<th scope="col">礦業及土石採取業</th>
									<th scope="col">製造業</th>
									<th scope="col">電力及燃氣供應業</th>
									<th scope="col">用水供應及污染整治業</th>
									<th scope="col">營建工程業</th>
									<th scope="col">批發及零售業</th>
									<th scope="col">運輸及倉儲業</th>
									<th scope="col">住宿及餐飲業</th>
									<th scope="col">出版、影音製作、傳播及資通訊服務業</th>
									<th scope="col">金融及保險業</th>
									<th scope="col">不動產業</th>
									<th scope="col">專業、科學及技術服務業</th>
									<th scope="col">支援服務業</th>
									<th scope="col">公共行政及國防；強制性社會安全</th>
									<th scope="col">教育業</th>
									<th scope="col">醫療保健及社會工作服務業</th>
									<th scope="col">藝術、娛樂及休閒服務業</th>
									<th scope="col">其他服務業</th>
									<th scope="col">工作體驗總時數</th>
							</thead>
							<tbody>
								<?php foreach ($counselEffectionWork as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['farmWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['miningWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['manufacturingWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['electricityWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['waterWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['buildWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['wholesaleWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['transportWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['hotelWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['publishWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['financialWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['immovablesWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['scienceWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['supportWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['militaryWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['educationWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['hospitalWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['artWorkCount'] : null ?></td>
										<td><?php echo $i ? $i['otherWorkCount'] : null ?></td>

										<td><?php echo $i ? $i['farmWorkCount'] + $i['miningWorkCount'] + $i['manufacturingWorkCount'] + $i['electricityWorkCount']
												+ $i['waterWorkCount'] + $i['buildWorkCount'] + $i['wholesaleWorkCount'] + $i['transportWorkCount']
												+ $i['hotelWorkCount'] + $i['publishWorkCount'] + $i['financialWorkCount'] + $i['immovablesWorkCount']
												+ $i['scienceWorkCount'] + $i['supportWorkCount'] + $i['militaryWorkCount'] + $i['educationWorkCount']
												+ $i['hospitalWorkCount'] + $i['artWorkCount'] + $i['otherWorkCount'] : null ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['farmWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['miningWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['manufacturingWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['electricityWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['waterWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['buildWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['wholesaleWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['transportWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['hotelWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['publishWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['financialWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['immovablesWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['scienceWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['supportWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['militaryWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['educationWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['hospitalWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['artWorkCount'] : null ?></td>
									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['otherWorkCount'] : null ?></td>

									<td><?php echo $counselEffectionWorkSumDetail ? $counselEffectionWorkSumDetail['farmWorkCount'] + $counselEffectionWorkSumDetail['miningWorkCount'] + $counselEffectionWorkSumDetail['manufacturingWorkCount'] + $counselEffectionWorkSumDetail['electricityWorkCount']
											+ $counselEffectionWorkSumDetail['waterWorkCount'] + $counselEffectionWorkSumDetail['buildWorkCount'] + $counselEffectionWorkSumDetail['wholesaleWorkCount'] + $counselEffectionWorkSumDetail['transportWorkCount']
											+ $counselEffectionWorkSumDetail['hotelWorkCount'] + $counselEffectionWorkSumDetail['publishWorkCount'] + $counselEffectionWorkSumDetail['financialWorkCount'] + $counselEffectionWorkSumDetail['immovablesWorkCount']
											+ $counselEffectionWorkSumDetail['scienceWorkCount'] + $counselEffectionWorkSumDetail['supportWorkCount'] + $counselEffectionWorkSumDetail['militaryWorkCount'] + $counselEffectionWorkSumDetail['educationWorkCount']
											+ $counselEffectionWorkSumDetail['hospitalWorkCount'] + $counselEffectionWorkSumDetail['artWorkCount'] + $counselEffectionWorkSumDetail['otherWorkCount'] : null ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'counselEffectionMeeting' || $reportType == 'all') { ?>

					<h4>跨局處會議及預防性講座統計表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.counselEffectionMeeting', '跨局處會議及預防性講座統計表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'counselEffectionMeeting' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="counselEffectionMeeting table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">跨局處會議</th>
									<th scope="col">預防性講座</th>
									<th scope="col">跨局處會議及預防性講座總次數</th>
							</thead>
							<tbody>
								<?php foreach ($counselEffectionMeeting as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['meetingCount'] : null ?></td>
										<td><?php echo $i ? $i['activityCount'] : null ?></td>
										<td><?php echo $i ? $i['meetingCount'] + $i['activityCount'] : null ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $counselEffectionMeetingSumDetail ? $counselEffectionMeetingSumDetail['meetingCount'] : null ?></td>
									<td><?php echo $counselEffectionMeetingSumDetail ? $counselEffectionMeetingSumDetail['activityCount'] : null ?></td>
									<td><?php echo $counselEffectionMeetingSumDetail ? $counselEffectionMeetingSumDetail['meetingCount'] + $counselEffectionMeetingSumDetail['activityCount'] : null ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeOldCaseTrack' || $reportType == 'all') { ?>
					<h4>前一年度開案後動向調查追蹤表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeOldCaseTrack', '前一年度開案後動向調查追蹤表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeOldCaseTrack' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 550px;">
						<table class="surveyTypeOldCaseTrack table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
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
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
							</thead>
							<tbody></tbody>
							<?php $count = 0; ?>
							<?php foreach ($surveyTypeOldCaseTrack as $i) { ?>
								<tr>
									<td><?php echo $i ? $i['name'] : null ?></td>
									<td><?php echo $i ? $i['already_working'] : null ?></td>
									<td><?php echo $i ? $i['already_attending_school'] : null ?></td>
									<td><?php echo $i ? $i['special_education_student'] : null ?></td>
									<td><?php echo $i ? $i['prepare_to_school'] : null ?></td>
									<td><?php echo $i ? $i['prepare_to_work'] : null ?></td>
									<td><?php echo $i ? $i['training'] : null ?></td>
									<td><?php echo $i ? $i['family_labor'] : null ?></td>
									<td><?php echo $i ? $i['health'] : null ?></td>
									<td><?php echo $i ? $i['no_plan'] : null ?></td>
									<td><?php echo $i ? $i['lost_contact'] : null ?></td>

									<td><?php echo $i ? $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
											+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
											+ $i['other'] : null ?></td>
									<td><?php echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
									<td><?php echo $i ? $i['youthCount'] : null ?></td>
									<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
											+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
											+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy'] + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
									<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
											+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
											+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
											+ $i['other'] : null ?></td>
									<td style="text-align:left"><?php echo $noteDetailOldCaseArray[$count] ?></td>
									<?php $count += 1; ?>
								</tr>
							<?php } ?>
							<tr>
								<td>總計</td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['already_working'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['already_attending_school'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['special_education_student'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['prepare_to_school'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['prepare_to_work'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['training'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['family_labor'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['health'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['no_plan'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['lost_contact'] : null ?></td>

								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['transfer_labor'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_one'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_two']
										+ $surveyTypeOldCaseTrackSumDetail['transfer_other_three'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_four'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_five'] + $surveyTypeOldCaseTrackSumDetail['pregnancy']
										+ $surveyTypeOldCaseTrackSumDetail['other'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['immigration'] + $surveyTypeOldCaseTrackSumDetail['death'] + $surveyTypeOldCaseTrackSumDetail['military'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['youthCount'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['prepare_to_school'] + $surveyTypeOldCaseTrackSumDetail['prepare_to_work'] + $surveyTypeOldCaseTrackSumDetail['training'] + $surveyTypeOldCaseTrackSumDetail['family_labor']
										+ $surveyTypeOldCaseTrackSumDetail['health'] + $surveyTypeOldCaseTrackSumDetail['no_plan'] + $surveyTypeOldCaseTrackSumDetail['lost_contact'] + $surveyTypeOldCaseTrackSumDetail['transfer_labor'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_one'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_two']
										+ $surveyTypeOldCaseTrackSumDetail['transfer_other_three'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_four'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_five'] + $surveyTypeOldCaseTrackSumDetail['pregnancy'] + $surveyTypeOldCaseTrackSumDetail['other'] + $surveyTypeOldCaseTrackSumDetail['immigration'] + $surveyTypeOldCaseTrackSumDetail['death'] + $surveyTypeOldCaseTrackSumDetail['military'] : null ?></td>
								<td><?php echo $surveyTypeOldCaseTrackSumDetail ? $surveyTypeOldCaseTrackSumDetail['prepare_to_school'] + $surveyTypeOldCaseTrackSumDetail['prepare_to_work'] + $surveyTypeOldCaseTrackSumDetail['training'] + $surveyTypeOldCaseTrackSumDetail['family_labor']
										+ $surveyTypeOldCaseTrackSumDetail['health'] + $surveyTypeOldCaseTrackSumDetail['no_plan'] + $surveyTypeOldCaseTrackSumDetail['lost_contact'] + $surveyTypeOldCaseTrackSumDetail['transfer_labor'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_one'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_two']
										+ $surveyTypeOldCaseTrackSumDetail['transfer_other_three'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_four'] + $surveyTypeOldCaseTrackSumDetail['transfer_other_five'] + $surveyTypeOldCaseTrackSumDetail['pregnancy']
										+ $surveyTypeOldCaseTrackSumDetail['other'] : null ?></td>
								<td></td>
								<?php $count += 1; ?>
							</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeTwoYears' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeTwoYears', '<?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeTwoYears' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="surveyTypeTwoYears table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市 / 類別</th>
									<th scope="col">01已就業</th>
									<th scope="col">02已就學</th>
									<th scope="col">03特教生</th>
									<th scope="col">04準備升學</th>
									<th scope="col">05準備或正在找工作</th>
									<th scope="col">06參加職訓</th>
									<th scope="col">07家務勞動</th>
									<th scope="col">08健康因素</th>
									<th scope="col">09尚未規劃</th>
									<th scope="col">10失聯</th>
									<th scope="col">11自學</th>
									<th scope="col">12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)</th>
									<th scope="col">13不可抗力(去世、司法問題、出國)</th>
									<th scope="col">需政府介入輔導人數(4-12)</th>
									<th scope="col">未升學未就業人數(4-13)</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeTwoYearsCounts as $i) { ?>
									<tr>
										<td><?php echo $i['name']; ?></td>
										<td><?php echo $i['surveyTypeNumberOne']; ?></td>
										<td><?php echo $i['surveyTypeNumberTwo']; ?></td>
										<td><?php echo $i['surveyTypeNumberThree']; ?></td>
										<td><?php echo $i['surveyTypeNumberFour']; ?></td>
										<td><?php echo $i['surveyTypeNumberFive']; ?></td>
										<td><?php echo $i['surveyTypeNumberSix']; ?></td>
										<td><?php echo $i['surveyTypeNumberSeven']; ?></td>
										<td><?php echo $i['surveyTypeNumberEight']; ?></td>
										<td><?php echo $i['surveyTypeNumberNine']; ?></td>
										<td><?php echo $i['surveyTypeNumberTen']; ?></td>
										<td><?php echo $i['surveyTypeNumberEleven'] ?></td>
										<td><?php echo $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree']
												+ $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>

										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberOne']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwo']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberThree']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberFour']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberFive']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberSix']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberSeven']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberEight']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberNine']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberTen']; ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberEleven'] ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeTwoYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeTwoYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeTwoYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberTwelveThree']
											+ $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeTwoYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeOneYears' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeOneYears', '<?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeOneYears' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="surveyTypeOneYears table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市 / 類別</th>
									<th scope="col">01已就業</th>
									<th scope="col">02已就學</th>
									<th scope="col">03特教生</th>
									<th scope="col">04準備升學</th>
									<th scope="col">05準備或正在找工作</th>
									<th scope="col">06參加職訓</th>
									<th scope="col">07家務勞動</th>
									<th scope="col">08健康因素</th>
									<th scope="col">09尚未規劃</th>
									<th scope="col">10失聯</th>
									<th scope="col">11自學</th>
									<th scope="col">12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)</th>
									<th scope="col">13不可抗力(去世、司法問題、出國)</th>
									<th scope="col">需政府介入輔導人數(4-12)</th>
									<th scope="col">未升學未就業人數(4-13)</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeOneYearsCounts as $i) { ?>
									<tr>
										<td><?php echo $i['name']; ?></td>
										<td><?php echo $i['surveyTypeNumberOne']; ?></td>
										<td><?php echo $i['surveyTypeNumberTwo']; ?></td>
										<td><?php echo $i['surveyTypeNumberThree']; ?></td>
										<td><?php echo $i['surveyTypeNumberFour']; ?></td>
										<td><?php echo $i['surveyTypeNumberFive']; ?></td>
										<td><?php echo $i['surveyTypeNumberSix']; ?></td>
										<td><?php echo $i['surveyTypeNumberSeven']; ?></td>
										<td><?php echo $i['surveyTypeNumberEight']; ?></td>
										<td><?php echo $i['surveyTypeNumberNine']; ?></td>
										<td><?php echo $i['surveyTypeNumberTen']; ?></td>
										<td><?php echo $i['surveyTypeNumberEleven'] ?></td>
										<td><?php echo $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree']
												+ $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>
										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberOne']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberTwo']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberThree']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberFour']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberFive']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberSix']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberSeven']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberEight']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberNine']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberTen']; ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberEleven'] ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeOneYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeOneYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeOneYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberTwelveThree']
											+ $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeOneYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeNowYears' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeNowYears', '<?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeNowYears' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 500px;">
						<table class="surveyTypeNowYears table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市 / 類別</th>
									<th scope="col">01已就業</th>
									<th scope="col">02已就學</th>
									<th scope="col">03特教生</th>
									<th scope="col">04準備升學</th>
									<th scope="col">05準備或正在找工作</th>
									<th scope="col">06參加職訓</th>
									<th scope="col">07家務勞動</th>
									<th scope="col">08健康因素</th>
									<th scope="col">09尚未規劃</th>
									<th scope="col">10失聯</th>
									<th scope="col">11自學</th>
									<th scope="col">12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)</th>
									<th scope="col">13不可抗力(去世、司法問題、出國)</th>
									<th scope="col">需政府介入輔導人數(4-12)</th>
									<th scope="col">未升學未就業人數(4-13)</th>

								</tr>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeNowYearsCounts as $i) { ?>
									<tr>
										<td><?php echo $i['name']; ?></td>
										<td><?php echo $i['surveyTypeNumberOne']; ?></td>
										<td><?php echo $i['surveyTypeNumberTwo']; ?></td>
										<td><?php echo $i['surveyTypeNumberThree']; ?></td>
										<td><?php echo $i['surveyTypeNumberFour']; ?></td>
										<td><?php echo $i['surveyTypeNumberFive']; ?></td>
										<td><?php echo $i['surveyTypeNumberSix']; ?></td>
										<td><?php echo $i['surveyTypeNumberSeven']; ?></td>
										<td><?php echo $i['surveyTypeNumberEight']; ?></td>
										<td><?php echo $i['surveyTypeNumberNine']; ?></td>
										<td><?php echo $i['surveyTypeNumberTen']; ?></td>
										<td><?php echo $i['surveyTypeNumberEleven'] ?></td>
										<td><?php echo $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree'] ?></td>
										<td><?php echo $i['surveyTypeNumberFour'] + $i['surveyTypeNumberFive'] + $i['surveyTypeNumberSix'] + $i['surveyTypeNumberSeven']
												+ $i['surveyTypeNumberEight'] + $i['surveyTypeNumberNine'] + $i['surveyTypeNumberTen'] + $i['surveyTypeNumberEleven']
												+ $i['surveyTypeNumberTwelve'] + $i['surveyTypeNumberTwelveOne'] + $i['surveyTypeNumberTwelveTwo'] + $i['surveyTypeNumberTwelveThree']
												+ $i['surveyTypeNumberThirteen'] + $i['surveyTypeNumberThirteenOne'] + $i['surveyTypeNumberThirteenTwo'] + $i['surveyTypeNumberThirteenThree'] ?></td>

										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberOne']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberTwo']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberThree']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberFour']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberFive']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberSix']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberSeven']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberEight']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberNine']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberTen']; ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberEleven'] ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeNowYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveThree'] ?></td>
									<td><?php echo $surveyTypeNowYearsSumDetail['surveyTypeNumberFour'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberFive'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberSix'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberSeven']
											+ $surveyTypeNowYearsSumDetail['surveyTypeNumberEight'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberNine'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTen'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberEleven']
											+ $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelve'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveOne'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveTwo'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberTwelveThree']
											+ $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteen'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenOne'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenTwo'] + $surveyTypeNowYearsSumDetail['surveyTypeNumberThirteenThree'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeHighSchoolTrack' || $reportType == 'all') { ?>
					<h4>109學年度高中已錄取未註冊青少年動向調查追蹤表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeHighSchoolTrack', '109年度高中已錄取未註冊青少年動向調查追蹤表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeHighSchoolTrack' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 550px;">
						<table class="surveyTypeHighSchoolTrack table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
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
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeHighSchoolTrack as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['already_working'] : null ?></td>
										<td><?php echo $i ? $i['already_attending_school'] : null ?></td>
										<td><?php echo $i ? $i['special_education_student'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_work'] : null ?></td>
										<td><?php echo $i ? $i['training'] : null ?></td>
										<td><?php echo $i ? $i['family_labor'] : null ?></td>
										<td><?php echo $i ? $i['health'] : null ?></td>
										<td><?php echo $i ? $i['no_plan'] : null ?></td>
										<td><?php echo $i ? $i['lost_contact'] : null ?></td>

										<td><?php echo $i ? $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td><?php echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['youthCount'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy'] + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td style="text-align:left"><?php echo str_replace("\n", "<br/>", $noteDetailHighSchoolArray[$count]); ?></td>
										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['already_working'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['already_attending_school'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['special_education_student'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['prepare_to_school'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['prepare_to_work'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['training'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['family_labor'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['health'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['no_plan'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['lost_contact'] : null ?></td>

									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['transfer_labor'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_one'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_two']
											+ $surveyTypeHighSchoolTrackSumDetail['transfer_other_three'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_four'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_five'] + $surveyTypeHighSchoolTrackSumDetail['pregnancy']
											+ $surveyTypeHighSchoolTrackSumDetail['other'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['immigration'] + $surveyTypeHighSchoolTrackSumDetail['death'] + $surveyTypeHighSchoolTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['youthCount'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['prepare_to_school'] + $surveyTypeHighSchoolTrackSumDetail['prepare_to_work'] + $surveyTypeHighSchoolTrackSumDetail['training'] + $surveyTypeHighSchoolTrackSumDetail['family_labor']
											+ $surveyTypeHighSchoolTrackSumDetail['health'] + $surveyTypeHighSchoolTrackSumDetail['no_plan'] + $surveyTypeHighSchoolTrackSumDetail['lost_contact'] + $surveyTypeHighSchoolTrackSumDetail['transfer_labor'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_one'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_two']
											+ $surveyTypeHighSchoolTrackSumDetail['transfer_other_three'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_four'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_five'] + $surveyTypeHighSchoolTrackSumDetail['pregnancy'] + $surveyTypeHighSchoolTrackSumDetail['other'] + $surveyTypeHighSchoolTrackSumDetail['immigration'] + $surveyTypeHighSchoolTrackSumDetail['death'] + $surveyTypeHighSchoolTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeHighSchoolTrackSumDetail ? $surveyTypeHighSchoolTrackSumDetail['prepare_to_school'] + $surveyTypeHighSchoolTrackSumDetail['prepare_to_work'] + $surveyTypeHighSchoolTrackSumDetail['training'] + $surveyTypeHighSchoolTrackSumDetail['family_labor']
											+ $surveyTypeHighSchoolTrackSumDetail['health'] + $surveyTypeHighSchoolTrackSumDetail['no_plan'] + $surveyTypeHighSchoolTrackSumDetail['lost_contact'] + $surveyTypeHighSchoolTrackSumDetail['transfer_labor'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_one'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_two']
											+ $surveyTypeHighSchoolTrackSumDetail['transfer_other_three'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_four'] + $surveyTypeHighSchoolTrackSumDetail['transfer_other_five'] + $surveyTypeHighSchoolTrackSumDetail['pregnancy']
											+ $surveyTypeHighSchoolTrackSumDetail['other'] : null ?></td>
									<td></td>
									<?php $count += 1; ?>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>


				<?php if ($reportType == 'surveyTypeTwoYearsTrack' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeTwoYearsTrack', '<?php echo $yearType - 4 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeTwoYearsTrack' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 550px;">
						<table class="surveyTypeTwoYearsTrack table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
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
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeTwoYearsTrack as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['already_working'] : null ?></td>
										<td><?php echo $i ? $i['already_attending_school'] : null ?></td>
										<td><?php echo $i ? $i['special_education_student'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_work'] : null ?></td>
										<td><?php echo $i ? $i['training'] : null ?></td>
										<td><?php echo $i ? $i['family_labor'] : null ?></td>
										<td><?php echo $i ? $i['health'] : null ?></td>
										<td><?php echo $i ? $i['no_plan'] : null ?></td>
										<td><?php echo $i ? $i['lost_contact'] : null ?></td>

										<td><?php echo $i ? $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td><?php echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['youthCount'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy'] + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>

										<td style="text-align:left"><?php echo str_replace("\n", "<br/>", $noteDetailTwoYearsArray[$count]); ?></td>
										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['already_working'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['already_attending_school'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['special_education_student'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['prepare_to_school'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['prepare_to_work'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['training'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['family_labor'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['health'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['no_plan'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['lost_contact'] : null ?></td>

									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['transfer_labor'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_one'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeTwoYearsTrackSumDetail['transfer_other_three'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_four'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_five'] + $surveyTypeTwoYearsTrackSumDetail['pregnancy']
											+ $surveyTypeTwoYearsTrackSumDetail['other'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['immigration'] + $surveyTypeTwoYearsTrackSumDetail['death'] + $surveyTypeTwoYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['youthCount'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['prepare_to_school'] + $surveyTypeTwoYearsTrackSumDetail['prepare_to_work'] + $surveyTypeTwoYearsTrackSumDetail['training'] + $surveyTypeTwoYearsTrackSumDetail['family_labor']
											+ $surveyTypeTwoYearsTrackSumDetail['health'] + $surveyTypeTwoYearsTrackSumDetail['no_plan'] + $surveyTypeTwoYearsTrackSumDetail['lost_contact'] + $surveyTypeTwoYearsTrackSumDetail['transfer_labor'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_one'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeTwoYearsTrackSumDetail['transfer_other_three'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_four'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_five'] + $surveyTypeTwoYearsTrackSumDetail['pregnancy'] + $surveyTypeTwoYearsTrackSumDetail['other'] + $surveyTypeTwoYearsTrackSumDetail['immigration'] + $surveyTypeTwoYearsTrackSumDetail['death'] + $surveyTypeTwoYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeTwoYearsTrackSumDetail ? $surveyTypeTwoYearsTrackSumDetail['prepare_to_school'] + $surveyTypeTwoYearsTrackSumDetail['prepare_to_work'] + $surveyTypeTwoYearsTrackSumDetail['training'] + $surveyTypeTwoYearsTrackSumDetail['family_labor']
											+ $surveyTypeTwoYearsTrackSumDetail['health'] + $surveyTypeTwoYearsTrackSumDetail['no_plan'] + $surveyTypeTwoYearsTrackSumDetail['lost_contact'] + $surveyTypeTwoYearsTrackSumDetail['transfer_labor'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_one'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeTwoYearsTrackSumDetail['transfer_other_three'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_four'] + $surveyTypeTwoYearsTrackSumDetail['transfer_other_five'] + $surveyTypeTwoYearsTrackSumDetail['pregnancy']
											+ $surveyTypeTwoYearsTrackSumDetail['other'] : null ?></td>
									<td></td>
									<?php $count += 1; ?>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeOneYearsTrack' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeOneYearsTrack', '<?php echo $yearType - 3 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeOneYearsTrack' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 550px;">
						<table class="surveyTypeOneYearsTrack table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
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
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeOneYearsTrack as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['already_working'] : null ?></td>
										<td><?php echo $i ? $i['already_attending_school'] : null ?></td>
										<td><?php echo $i ? $i['special_education_student'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_work'] : null ?></td>
										<td><?php echo $i ? $i['training'] : null ?></td>
										<td><?php echo $i ? $i['family_labor'] : null ?></td>
										<td><?php echo $i ? $i['health'] : null ?></td>
										<td><?php echo $i ? $i['no_plan'] : null ?></td>
										<td><?php echo $i ? $i['lost_contact'] : null ?></td>

										<td><?php echo $i ? $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td><?php echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['youthCount'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy'] + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td style="text-align:left"><?php echo str_replace("\n", "<br/>", $noteDetailOneYearsArray[$count]); ?></td>
										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['already_working'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['already_attending_school'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['special_education_student'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['prepare_to_school'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['prepare_to_work'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['training'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['family_labor'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['health'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['no_plan'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['lost_contact'] : null ?></td>

									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['transfer_labor'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_one'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeOneYearsTrackSumDetail['transfer_other_three'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_four'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_five'] + $surveyTypeOneYearsTrackSumDetail['pregnancy']
											+ $surveyTypeOneYearsTrackSumDetail['other'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['immigration'] + $surveyTypeOneYearsTrackSumDetail['death'] + $surveyTypeOneYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['youthCount'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['prepare_to_school'] + $surveyTypeOneYearsTrackSumDetail['prepare_to_work'] + $surveyTypeOneYearsTrackSumDetail['training'] + $surveyTypeOneYearsTrackSumDetail['family_labor']
											+ $surveyTypeOneYearsTrackSumDetail['health'] + $surveyTypeOneYearsTrackSumDetail['no_plan'] + $surveyTypeOneYearsTrackSumDetail['lost_contact'] + $surveyTypeOneYearsTrackSumDetail['transfer_labor'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_one'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeOneYearsTrackSumDetail['transfer_other_three'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_four'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_five'] + $surveyTypeOneYearsTrackSumDetail['pregnancy'] + $surveyTypeOneYearsTrackSumDetail['other'] + $surveyTypeOneYearsTrackSumDetail['immigration'] + $surveyTypeOneYearsTrackSumDetail['death'] + $surveyTypeOneYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeOneYearsTrackSumDetail ? $surveyTypeOneYearsTrackSumDetail['prepare_to_school'] + $surveyTypeOneYearsTrackSumDetail['prepare_to_work'] + $surveyTypeOneYearsTrackSumDetail['training'] + $surveyTypeOneYearsTrackSumDetail['family_labor']
											+ $surveyTypeOneYearsTrackSumDetail['health'] + $surveyTypeOneYearsTrackSumDetail['no_plan'] + $surveyTypeOneYearsTrackSumDetail['lost_contact'] + $surveyTypeOneYearsTrackSumDetail['transfer_labor'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_one'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeOneYearsTrackSumDetail['transfer_other_three'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_four'] + $surveyTypeOneYearsTrackSumDetail['transfer_other_five'] + $surveyTypeOneYearsTrackSumDetail['pregnancy']
											+ $surveyTypeOneYearsTrackSumDetail['other'] : null ?></td>
									<td></td>
									<?php $count += 1; ?>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if ($reportType == 'surveyTypeNowYearsTrack' || $reportType == 'all') { ?>
					<h4><?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表</h4>
					<!-- <a class="btn btn-success" onclick="exportTableToCSV('.surveyTypeNowYearsTrack', '<?php echo $yearType - 2 ?>學年度國中畢業未升學未就業青少年動向調查追蹤表.csv')">列印(下載CSV檔)</a> -->
					<a class="btn btn-success" href="<?php echo site_url('export/yda_report_export/' . 'surveyTypeNowYearsTrack' . '/' . $yearType); ?>">列印(下載CSV檔)</a><br /><br />
					<div class="table-responsive" style="max-height: 550px;">
						<table class="surveyTypeNowYearsTrack table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
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
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($surveyTypeNowYearsTrack as $i) { ?>
									<tr>
										<td><?php echo $i ? $i['name'] : null ?></td>
										<td><?php echo $i ? $i['already_working'] : null ?></td>
										<td><?php echo $i ? $i['already_attending_school'] : null ?></td>
										<td><?php echo $i ? $i['special_education_student'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_work'] : null ?></td>
										<td><?php echo $i ? $i['training'] : null ?></td>
										<td><?php echo $i ? $i['family_labor'] : null ?></td>
										<td><?php echo $i ? $i['health'] : null ?></td>
										<td><?php echo $i ? $i['no_plan'] : null ?></td>
										<td><?php echo $i ? $i['lost_contact'] : null ?></td>

										<td><?php echo $i ? $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td><?php echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['youthCount'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy'] + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null ?></td>
										<td><?php echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
												+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other_one'] + $i['transfer_other_two']
												+ $i['transfer_other_three'] + $i['transfer_other_four'] + $i['transfer_other_five'] + $i['pregnancy']
												+ $i['other'] : null ?></td>
										<td style="text-align:left"><?php echo str_replace("\n", "<br/>", $noteDetailNowYearsArray[$count]); ?></td>
										<?php $count += 1; ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['already_working'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['already_attending_school'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['special_education_student'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['prepare_to_school'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['prepare_to_work'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['training'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['family_labor'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['health'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['no_plan'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['lost_contact'] : null ?></td>

									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['transfer_labor'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_one'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeNowYearsTrackSumDetail['transfer_other_three'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_four'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_five'] + $surveyTypeNowYearsTrackSumDetail['pregnancy']
											+ $surveyTypeNowYearsTrackSumDetail['other'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['immigration'] + $surveyTypeNowYearsTrackSumDetail['death'] + $surveyTypeNowYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['youthCount'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['prepare_to_school'] + $surveyTypeNowYearsTrackSumDetail['prepare_to_work'] + $surveyTypeNowYearsTrackSumDetail['training'] + $surveyTypeNowYearsTrackSumDetail['family_labor']
											+ $surveyTypeNowYearsTrackSumDetail['health'] + $surveyTypeNowYearsTrackSumDetail['no_plan'] + $surveyTypeNowYearsTrackSumDetail['lost_contact'] + $surveyTypeNowYearsTrackSumDetail['transfer_labor'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_one'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeNowYearsTrackSumDetail['transfer_other_three'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_four'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_five'] + $surveyTypeNowYearsTrackSumDetail['pregnancy'] + $surveyTypeNowYearsTrackSumDetail['other'] + $surveyTypeNowYearsTrackSumDetail['immigration'] + $surveyTypeNowYearsTrackSumDetail['death'] + $surveyTypeNowYearsTrackSumDetail['military'] : null ?></td>
									<td><?php echo $surveyTypeNowYearsTrackSumDetail ? $surveyTypeNowYearsTrackSumDetail['prepare_to_school'] + $surveyTypeNowYearsTrackSumDetail['prepare_to_work'] + $surveyTypeNowYearsTrackSumDetail['training'] + $surveyTypeNowYearsTrackSumDetail['family_labor']
											+ $surveyTypeNowYearsTrackSumDetail['health'] + $surveyTypeNowYearsTrackSumDetail['no_plan'] + $surveyTypeNowYearsTrackSumDetail['lost_contact'] + $surveyTypeNowYearsTrackSumDetail['transfer_labor'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_one'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_two']
											+ $surveyTypeNowYearsTrackSumDetail['transfer_other_three'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_four'] + $surveyTypeNowYearsTrackSumDetail['transfer_other_five'] + $surveyTypeNowYearsTrackSumDetail['pregnancy']
											+ $surveyTypeNowYearsTrackSumDetail['other'] : null ?></td>
									<td></td>
									<?php $count += 1; ?>
								</tr>
							</tbody>
						</table>
					</div>
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
		var rows = document.querySelectorAll(report + " tr");

		for (var i = 0; i < rows.length; i++) {
			var row = [],
				cols = rows[i].querySelectorAll("td, th");

			for (var j = 0; j < cols.length; j++)
				row.push(cols[j].innerText);

			csv.push(row.join(","));
		}

		// Download CSV file
		downloadCSV(csv.join("\n"), filename);
	}
</script>
<?php $this->load->view('templates/new_footer'); ?>
