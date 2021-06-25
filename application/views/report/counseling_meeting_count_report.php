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
					<a class="btn btn-success" style="margin:10px;" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
				</div>
			</div> -->
			<h4 class="card-title text-center"><?php echo $title ?></h4>

			<div class="card-content">

				<form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<!-- <a class="btn col s2 offset-s5 waves-effect blue darken-4" href="<?php echo site_url('/report/month_member_temp_counseling/' . $yearType . '/' . $monthType); ?>">輔導成效概況表</a> -->

					<?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
					<?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : '';
					$total = 0; ?>
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
					<h3><?php if (isset($get_inserted_meeting_count_data)) {
							// echo "EDIT";
						} elseif (isset($actual_meeting_date_count)) {
							// echo "新增" . $plus_month;
						} ?></h3>

					<!-- <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <select name="years" id="years" onchange="location = this.value;">

                <?php foreach ($years as $i) { ?>
                  <option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
                <?php } ?>

              </select>
              <label>年度</label>
            </div>
          </div>

          
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <select name="months" id="months" onchange="location = this.value;">

                <?php foreach ($months as $i) { ?>

                  <option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
                <?php } ?>

              </select>
              <label>月份</label>
            </div>
          </div>

         
          <div class="row">
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
          </div> -->

					<?php
					$url_parts = explode('/', $_SERVER['REQUEST_URI']);
					$get_organ = 0; //縣市對應的所有organization num

					$year = $yearType + 1911;
					$month = $monthType;

					?>

					<table class="table table-hover table-bordered aligin-middle text-center" style="border:2px grey solid;">
						<thead>
							<tr>
								<th scope="col">預計辦理跨局處會議場次</th>
								<th scope="col">目前辦理跨局處會議時間</th>
								<th scope="col">目前辦理活動或講座場次</th>
								<th scope="col">目前活動或講座參與人次</th>
							</tr>

						</thead>
						<tbody>
							<tr>
								<td><?php echo $projects->meeting_count; ?></td>
								<td><?php echo str_replace("\n", "<br/>", $meetingTimeDetail); ?></td>
								<td><?php echo $actualCount ?></td>
								<td><?php echo $sumParticipant; ?></td>

							</tr>
						</tbody>
					</table>

					<br />

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label for="planning_holding_meeting_count" class="form-label">預計辦理活動或講座場次</label>
							<input class="form-control" type="number" min="0" id="planning_holding_meeting_count" name="planning_holding_meeting_count" value="<?php echo (empty($get_inserted_meeting_count_data)) ? "" : $get_inserted_meeting_count_data->planning_holding_meeting_count ?>" <?php echo (empty($counselingMemberCountReport->funding_execute)) ? "" : "" ?>>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label for="planning_involved_people" class="form-label">預計活動或講座參與人次</label>
							<input class="form-control" type="number" min="0" id="planning_involved_people" name="planning_involved_people" value="<?php echo (empty($get_inserted_meeting_count_data)) ? "" : $get_inserted_meeting_count_data->planning_involved_people ?>" <?php echo (empty($counselingMemberCountReport->funding_execute)) ? "" : "" ?>>
						</div>
					</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-sm-10 col-md-8 mb-3">
					<label for="meeting_count_note" class="form-label">備註</label>
					<textarea required readonly class="form-control" id="meeting_count_note" name="meeting_count_note" style="height: 100px" <?php echo ($get_inserted_meeting_count_data) ? '' : '' ?>><?php echo (empty($get_inserted_meeting_count_data)) ? $planningNoteDetail . "\n" . $actualNoteDetail : (($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $planningNoteDetail . "\n" . $actualNoteDetail : $get_inserted_meeting_count_data->meeting_count_note); ?></textarea>
				</div>
			</div>
		</div>


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


		<br /><br />

		<?php if ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) : ?>


			<input type="hidden" name="check_update" value="update">
			<div class="row justify-content-center">
				<div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
					<?php if (empty($get_inserted_meeting_count_data)) {
						echo "<input type='hidden' name='check_create' value='create'>";
					}
					?>
					<button class='btn btn-primary' type='submit'>暫存</button>
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
