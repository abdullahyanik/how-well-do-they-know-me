<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/chartist/css/chartist-custom.css">
<div class="panel panel-headline">
<div class="panel-body">
<h3><?php _e("stats"); ?></h3>
<div class="row" style="padding-top:20px">
	<div class="col-md-4">
		<div class="metric">
			<span class="icon"><i class="fa fa-rocket"></i></span>
			<p><span class="number"><?php echo $totalQuizCount; ?></span><span class="title"><?php _e("totalQuizCount"); ?></span></p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="metric">
			<span class="icon"><i class="fa fa-anchor"></i></span>
			<p><span class="number"><?php echo $totalQuizAnswersCount; ?></span><span class="title"><?php _e("totalQuizAnswersCount"); ?></span></p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="metric">
			<span class="icon"><i class="fa fa-code"></i></span>
			<p><span class="number"><?php echo APP_VERSION; ?></span><span class="title"><?php _e("applicationVersion"); ?></span></p>
		</div>
	</div>
</div>
</div>
</div>
<div class="panel">
<div style="display:flex;align-items:center">
	<div style="flex:1">
	<div class="panel-heading" style="padding-bottom:0">
		<h3 style="margin-bottom:0"><?php _e("announcementBox"); ?></h3>
	</div>
	<div class="panel-body" style="padding-bottom:40px">
		<h4 style="padding-bottom:10px"><?php echo $update["announcement"]; ?></h4>
		<span><?php echo $update["announcement_date"]; ?></span>
	</div>
	</div>
	<div>
		<i class="fa fa-bullhorn fa-4x text-primary" style="margin-right:40px"></i>
	</div>
</div>
</div>
<div class="panel">
<div class="panel-heading">
<h3><?php _e("last10DaysStats"); ?></h3>
</div>
<div class="panel-body">
	<div id="line-chart" style="margin-bottom:20px" class="ct-chart"></div>
</div>
</div>

<script>
$(function() {
var d = <?php echo json_encode($statsData); ?>;
var data = {
	labels: d["labels"],
	series: [
		d["series"],
	]
};
options = {
	height: "300px",
	showPoint: true,
	axisX: {
		showGrid: false
	},
	lineSmooth: false,
};

new Chartist.Line("#line-chart", data, options);
});
</script>
<script src="assets/admin/vendor/chartist/js/chartist.min.js"></script>