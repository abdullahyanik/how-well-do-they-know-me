<?php defined("SITE_URL") or die(); ?>
<!DOCTYPE html>
<html lang="<?php echo $Configs["language"]; ?>">
<head>
    <base href="<?php echo SITE_URL; ?>">
    <meta charset="utf-8">
    <title><?php _e("pageNotFound"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800|Roboto:400,500,700" rel="stylesheet">
    <link type="text/css" href="assets/css/theme.css" rel="stylesheet">
</head>
<body style="height:100vh" class="d-flex">
    <div class="container h-100">
        <div class="row align-items-center h-100 justify-content-center">
            <div class="col-lg-5 text-center">
                <img src="assets/img/404.png" alt="<?php _e("pageNotFound"); ?>" class="mw-100">
                <h1 class="my-4"><?php _e("pageNotFound"); ?></h1>
                <p class="mb-4"><?php _e("pageNotFoundText"); ?></p>
                <a href="./"><button class="btn btn-primary"><?php _e("backToHome"); ?></button></a>
            </div>
        </div>
    </div>
</body>
</html>