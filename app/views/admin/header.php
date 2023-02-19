<?php defined("SITE_URL") or die(); ?>
<!doctype html>
<html lang="<?php echo $Configs["language"]; ?>">

<head>
	<base href="<?php echo SITE_URL; ?>">
	<title><?php echo $title; ?> - <?php _e("adminPanel"); ?></title>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/admin/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/admin/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/admin/css/theme.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
	<script src="assets/admin/vendor/jquery/jquery.min.js"></script>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="./admin"><?php _e("adminPanel"); ?></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div class="navbar-btn navbar-btn-right">
					<a class="btn btn-danger" href="admin/logout"><i class="fa fa-sign-out mr-2"></i> <span><?php _e("logout"); ?></span></a>
				</div>
			</div>
		</nav>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="./admin" class="<?php echo $title == $Strings->g("dashboard") ? "active": ""; ?>"><i class="lnr lnr-home"></i> <span><?php _e("dashboard"); ?></span></a></li>
						<li><a href="./admin/questions" class="<?php echo $title == $Strings->g("questions") ? "active": ""; ?>"><i class="lnr lnr-question-circle"></i> <span><?php _e("questions"); ?></span></a></li>
						<li><a href="./admin/pages" class="<?php echo $title == $Strings->g("pages") ? "active": ""; ?>"><i class="lnr lnr-file-empty"></i> <span><?php _e("pages"); ?></span></a></li>
						<li><a href="./admin/blogs" class="<?php echo $title == $Strings->g("blogPosts") ? "active": ""; ?>"><i class="lnr lnr-pencil"></i> <span><?php _e("blogPosts"); ?></span></a></li>
						<li><a href="./admin/contact-form" class="<?php echo $title == $Strings->g("contactMessages") ? "active": ""; ?>"><i class="lnr lnr-phone"></i> <span><?php _e("contactMessages"); ?></span></a></li>
						<li>
                            <a href="#subSettings" data-toggle="collapse" class="<?php echo isset($data["settings"]) ? "active": "collapsed"; ?>"><i class="lnr lnr-cog"></i> <span><?php _e("settings"); ?></span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="subSettings" class="<?php echo isset($data["settings"]) ? "active collapse in": "collapse"; ?>">
                                <ul class="nav">
									<li><a href="./admin/settings/general" class="<?php echo isset($data["settings"]) && $data["settings"] == "general" ? "active" : ""; ?>"><?php _e("generalSettings"); ?></a></li>
									<li><a href="./admin/settings/ads" class="<?php echo isset($data["settings"]) && $data["settings"] == "ads" ? "active" : ""; ?>"><?php _e("adsSettings"); ?></a></li>
									<li><a href="./admin/settings/design" class="<?php echo isset($data["settings"]) && $data["settings"] == "design" ? "active" : ""; ?>"><?php _e("designSettings"); ?></a></li>
									<li><a href="./admin/settings/profile" class="<?php echo isset($data["settings"]) && $data["settings"] == "profile" ? "active" : ""; ?>"><?php _e("profileSettings"); ?></a></li>
								</ul>
                            </div>
                        </li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title"><?php echo $title; ?></h3>