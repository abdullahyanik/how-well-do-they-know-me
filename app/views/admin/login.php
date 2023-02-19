<?php defined("SITE_URL") or die(); ?>
<!doctype html>
<html lang="<?php echo $Configs["language"]; ?>" class="fullscreen-bg">

<head>
    <base href="<?php echo SITE_URL; ?>">
	<title><?php echo _e("login"); ?> - <?php _e("adminPanel"); ?></title>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/admin/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/admin/vendor/linearicons/style.css">
    <link rel="stylesheet" href="assets/admin/css/theme.min.css">
    <link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <script src="assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="assets/admin/vendor/toastr/toastr.min.js"></script>
</head>

<body>
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<p class="lead"><?php _e("loginToPanel"); ?></p>
							</div>
							<form class="form-auth-small" action="" method="post" id="loginForm">
								<div class="form-group">
									<input required="" type="text" class="form-control" id="signin-username" name="username" placeholder="<?php _e("enterUsername"); ?>">
								</div>
								<div class="form-group">
									<input required="" type="password" class="form-control" id="signin-password" name="password" placeholder="<?php _e("enterPassword"); ?>">
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block"><?php _e("login"); ?></button>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading"><?php _e("loginText"); ?></h1>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
    </div>
    <script type="text/javascript">
    var login = false;
    $("#loginForm").submit(function(e) {
        e.preventDefault();
        if(!login) {
        var form = $(this);
        $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: form.serialize(),
        success: function(data) {
            data = JSON.parse(data);
            if(data.success) {
                toastr.success(data.message);
                login = true;
                setTimeout(function() {
                    window.location.href = "./admin";
                }, 2000);
            }
            else {
                toastr.error(data.message);
            }
            }
        });
        }
    });
    </script>
</body>
</html>
