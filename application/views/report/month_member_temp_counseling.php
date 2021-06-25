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
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/report/counseling_member_count_report_table/'.$yearType.'/'.$monthType);?>"><?php echo '每月執行進度表清單';?></a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/report/counseling_member_count_report/'.$yearType.'/'.$monthType);?>"><?php echo '表一.輔導人數統計表/執行進度表';?></a>
			</li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
		</ol>
	</nav>
</div>
<div class="container" style="width: 90%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<h4 class="card-title text-center"><?php echo $title ?></h4>
			<div class="card-content">
				<form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
					<?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
					<?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>
					<!-- years -->
					<div class="row justify-content-center">
						<div class=" col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

								<?php foreach ($years as $i) { ?>

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/month_member_temp_counseling/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
								<?php } ?>

							</select>

						</div>
					</div>

					<!-- months -->
					<div class="row justify-content-center">
						<div class=" col-sm-10 col-md-8 mb-3">
							<label>月份</label>
							<select class="form-select form-select-lg" name="months" id="months" onchange="location = this.value;">

								<?php foreach ($months as $i) { ?>

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/month_member_temp_counseling/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>

						</div>
					</div>

					<table class="table table-hover align-middle text-center">
						<thead class="thead-dark">
							<tr>
								<th scope="col">編號</th>
								<th scope="col">身分證</th>
								<th scope="col">姓名</th>
								<th scope="col">輔導成效</th>
								<th scope="col">備註</th>
							</tr>
						</thead>
						<tbody>
							<?php if (1 == 0) : ?>

								<?php foreach ($monthMemberTempCounselings as $i) { ?>

									<tr>
										<td><?php echo $i['system_no']; ?></td>
										<td><?php echo $i['identifications']; ?></td>
										<td><?php echo $i['name']; ?></td>
										<td>
											<!-- trend -->
											<div class="row">
												<div class="input-field col-sm-10 col-md-8">
													<label>動向</label>
													<select class="form-select" name="trend[]" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
														<?php if (empty($i['end_trend'])) : ?>
															<?php if (empty($i['trend'])) { ?>
																<option selected value="">請選擇</option>
																<?php }
															foreach ($trends as $v) {
																if (!empty($i['trend'])) {
																	if ($v['no'] == $i['trend']) { ?>
																		<option selected value="<?php echo $v['no']; ?>"><?php echo $v['content']; ?></option>
																	<?php } else { ?>
																		<option value="<?php echo $v['no']; ?>"><?php echo $v['content']; ?></option>
																	<?php }
																} else { ?>
																	<option value="<?php echo $v['no']; ?>"><?php echo $v['content']; ?></option>
																<?php } ?>
															<?php } ?>
														<?php else : ?>
															<?php
															foreach ($trends as $v) {
																if ($v['no'] == $i['end_trend']) : ?>
																	<option selected value="<?php echo $v['no']; ?>"><?php echo $v['content']; ?></option>
																<?php endif; ?>

														<?php }
														endif; ?>
													</select>
												</div>
											</div>
										</td>
										<td>
											<!-- trendDescription -->
											<div class="row">
												<div class=" col-sm-10 col-md-8">
													<label for="formTrendDescription">備註</label>
													<input class="form-control" type="text" id="formTrendDescription" name="trendDescription[]" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo $i['trend_description'] ?>">
												</div>
											</div>
										</td>
									</tr>

								<?php } ?>

							<?php else : ?>

								<?php foreach ($members as $i) {
									$trendMote = ""; ?>

									<tr>
										<td><?php echo $i['system_no']; ?></td>
										<td><?php echo $i['identifications']; ?></td>
										<td><?php echo $i['name']; ?></td>
										<td>
											<!-- trend -->
											<div class="form-floating ">
													<select class="form-select" name="trend[]" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
														<option selected disabled value="">請選擇</option>
														<?php
														foreach ($trends as $j) {
															if ($i['trend'] == $j['no']) : ?>
																<option selected value="<?php echo $j['no']; ?>"><?php echo $j['content']; ?></option>
															<?php break;
															else : ?>
																<option value="<?php echo $j['no']; ?>"><?php echo $j['content']; ?></option>
															<?php endif; ?>


														<?php } ?>
														<?php if ($monthMemberTempCounselings) {
															foreach ($monthMemberTempCounselings as $value) {
																if ($value['member'] == $i['no']) {
																	$trendMote = $value['trend_description'];
																	foreach ($trends as $j) {
																		if ($value['trend'] == $j['no']) { ?>
																			<option selected value="<?php echo $j['no']; ?>"><?php echo $j['content']; ?></option>
																		<?php } else { ?>

																		<?php } ?>
																	<?php } ?>
																<?php } ?>
															<?php } ?>

														<?php } ?>
													</select>
													<label for="floatingSelect">動向</label>
												</div>
											</div>
										</td>
										<td>
											<!-- trendDescription -->
												<div class="form-floating">
													<label for="formTrendDescription">備註</label>
													<input class="form-control" type="text" id="formTrendDescription" name="trendDescription[]" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value=<?php echo $trendMote ? $trendMote : "" ?>>
												</div>
										</td>
									</tr>
								<?php } ?>
							<?php endif; ?>
						</tbody>
					</table>

					<?php if ($hasDelegation != '0') : ?>
						<div class="row justify-content-center">
							<div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
								<button class="btn btn-primary" type="submit">送出</button>
							</div>
						</div>
					<?php endif; ?>

				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/new_footer'); ?>
