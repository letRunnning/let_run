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

							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $trendCount ?  $trendCount['alreadyWorking'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['alreadyAttendingSchool'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['specialEducationStudent'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['prepareToSchool'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['prepareToWork'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['training'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['familyLabor'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['health'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['noPlan'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['lostContact'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['transferLabor'] + $trendCount['transferOther'] + $trendCount['pregnancy'] + $trendCount['other'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['immigration'] + $trendCount['death'] + $trendCount['military'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['inCase'] : null ?></td>
								<td><?php echo $youthCount ? $youthCount : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['prepareToSchool'] + $trendCount['prepareToWork'] + $trendCount['training'] + $trendCount['familyLabor'] + $trendCount['health'] + $trendCount['noPlan'] + $trendCount['lostContact'] + $trendCount['transferLabor'] + $trendCount['transferOther'] + $trendCount['pregnancy'] + $trendCount['other'] + $trendCount['immigration'] + $trendCount['death'] + $trendCount['military'] : null ?></td>
								<td><?php echo $trendCount ?  $trendCount['prepareToSchool'] + $trendCount['prepareToWork'] + $trendCount['training'] + $trendCount['familyLabor'] + $trendCount['health'] + $trendCount['noPlan'] + $trendCount['lostContact'] + $trendCount['transferLabor'] + $trendCount['transferOther'] + $trendCount['pregnancy'] + $trendCount['other'] : null ?></td>
							</tr>
						</tbody>
					</table>

					<br />

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8">
							<label for="note" class="form-label">備註*</label>
							<textarea required id="note" class="form-control" name="note" style="height: 100px"<?php echo ($oneYearsTrendSurveyCountReports) ? '' : '' ?>><?php echo (empty($oneYearsTrendSurveyCountReports)) ? $noteDetail : $oneYearsTrendSurveyCountReports->note ?></textarea>
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
					<?php endif; ?>


				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/new_footer'); ?>
