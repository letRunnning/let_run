<div class="card">
	<div class="card-content">
		<div class="dashboard_card">
			<h3 class="dashboard_card_title">執行狀況 </h3>
			<div>
				<h5>執行縣市 : <?php echo $statisticsData->countyCount ?>個</h5>
				<h5>輔導員 : <?php echo $statisticsData->counselorCount ?>位</h5>
				<h5>學員 : <?php echo $statisticsData->memberCount ?>位</h5>
				<h5>輔導(措施A)執行 : <?php echo $statisticsData->individualCounselingHour + $statisticsData->groupCounselingHour ?>小時</h5>
				<h5>課程(措施B)執行 : <?php echo $statisticsData->courseAttendanceHour ?>小時</h5>
				<h5>工作體驗(措施C執行) : <?php echo $statisticsData->workAttendanceHour ?>小時</h5>
			</div>
		</div>
	</div>
</div>